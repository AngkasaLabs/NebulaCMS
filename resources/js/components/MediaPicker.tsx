import { useState, useEffect } from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ImageIcon, UploadIcon } from 'lucide-react';
import { sanitizeUrl } from '@/utils/urlValidator';

interface Media {
    id: number;
    name: string;
    url?: string;
}

interface MediaPickerProps {
    media: Media[];
    selectedMediaId?: string;
    onSelect: (mediaId: string) => void;
    onUpload: (file: File) => void;
    featuredImageUrl?: string;
}

export default function MediaPicker({ media, selectedMediaId, onSelect, onUpload, featuredImageUrl }: MediaPickerProps) {
    const [isOpen, setIsOpen] = useState(false);
    const [activeTab, setActiveTab] = useState('upload');
    const [previewUrl, setPreviewUrl] = useState<string | undefined>(sanitizeUrl(featuredImageUrl || ''));

    useEffect(() => {
        // Cleanup old preview URL when component unmounts or when new file is selected
        return () => {
            if (previewUrl && previewUrl !== featuredImageUrl) {
                URL.revokeObjectURL(previewUrl);
            }
        };
    }, [previewUrl, featuredImageUrl]);

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            // Cleanup old preview if exists
            if (previewUrl && previewUrl !== featuredImageUrl) {
                URL.revokeObjectURL(previewUrl);
            }

            // Create new preview
            const newPreviewUrl = URL.createObjectURL(file);
            setPreviewUrl(newPreviewUrl);
            onUpload(file);
            setIsOpen(false);
        }
    };

    const handleMediaSelect = (mediaId: string, url?: string) => {
        // Cleanup file preview if exists
        if (previewUrl && previewUrl !== featuredImageUrl) {
            URL.revokeObjectURL(previewUrl);
        }
        setPreviewUrl(sanitizeUrl(url || ''));
        onSelect(mediaId);
        setIsOpen(false);
    };

    const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            // Cleanup old preview if exists
            if (previewUrl && previewUrl !== featuredImageUrl) {
                URL.revokeObjectURL(previewUrl);
            }

            // Create new preview
            const newPreviewUrl = URL.createObjectURL(file);
            setPreviewUrl(newPreviewUrl);
            onUpload(file);
            setIsOpen(false);
        }
    };

    const handleDragOver = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
    };

    return (
        <div className="space-y-4">
            <div className="flex items-center gap-4">
                {previewUrl ? (
                    <div className="relative group">
                        <img
                            src={sanitizeUrl(previewUrl)}
                            alt="Featured"
                            className="w-[200px] h-[150px] object-cover rounded-lg border border-gray-700"
                        />
                        <div className="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                            <Button
                                variant="outline"
                                className="text-white border-white hover:bg-white hover:text-black"
                                onClick={() => setIsOpen(true)}
                            >
                                Ganti Gambar
                            </Button>
                        </div>
                    </div>
                ) : (
                    <Button
                        variant="outline"
                        className="h-[150px] w-[200px] border-dashed border-2 flex flex-col items-center justify-center gap-2 hover:border-white"
                        onClick={() => setIsOpen(true)}
                    >
                        <ImageIcon className="h-8 w-8" />
                        <span>Select Featured Image</span>
                    </Button>
                )}
            </div>

            <Dialog open={isOpen} onOpenChange={setIsOpen}>
                <DialogContent className="max-w-3xl">
                    <DialogHeader>
                        <DialogTitle>Select Media</DialogTitle>
                    </DialogHeader>

                    <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
                        <TabsList className="w-full">
                            <TabsTrigger value="upload" className="w-full">
                                <UploadIcon className="w-4 h-4 mr-2" />
                                Upload
                            </TabsTrigger>
                            <TabsTrigger value="media" className="w-full">
                                <ImageIcon className="w-4 h-4 mr-2" />
                                Media Library
                            </TabsTrigger>
                        </TabsList>

                        <TabsContent value="upload" className="mt-4">
                            <div className="space-y-4">
                                <div
                                    className="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer"
                                    onDrop={handleDrop}
                                    onDragOver={handleDragOver}
                                >
                                    <Label htmlFor="file-upload" className="cursor-pointer">
                                        <UploadIcon className="mx-auto h-12 w-12 text-gray-400" />
                                        <span className="mt-2 block text-sm font-medium">
                                            Click to upload or drag & drop
                                        </span>
                                        <span className="mt-1 block text-xs text-gray-400">
                                            PNG, JPG, GIF up to 10MB
                                        </span>
                                    </Label>
                                    <Input
                                        id="file-upload"
                                        type="file"
                                        className="hidden"
                                        onChange={handleFileChange}
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                        </TabsContent>

                        <TabsContent value="media" className="mt-4">
                            <div className="grid grid-cols-3 gap-4">
                                {media.map((item) => (
                                    <div
                                        key={item.id}
                                        className={`relative group cursor-pointer rounded-lg overflow-hidden ${
                                            selectedMediaId === item.id.toString()
                                                ? 'ring-2 ring-white'
                                                : ''
                                        }`}
                                        onClick={() => handleMediaSelect(item.id.toString(), item.url)}
                                    >
                                        {item.url ? (
                                            <img
                                                src={item.url}
                                                alt={item.name}
                                                className="w-full h-32 object-cover"
                                            />
                                        ) : (
                                            <div className="w-full h-32 bg-gray-800 flex items-center justify-center">
                                                <ImageIcon className="w-8 h-8 text-gray-400" />
                                            </div>
                                        )}
                                        <div className="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span className="text-white text-sm">{item.name}</span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </TabsContent>
                    </Tabs>
                </DialogContent>
            </Dialog>
        </div>
    );
}
